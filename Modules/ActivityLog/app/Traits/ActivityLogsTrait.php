<?php

namespace Modules\ActivityLog\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait ActivityLogsTrait
{
    /**
     * Create an activity log (Create/Update/Delete).
     */
    public function ActivityLogCreate(array $data, string $message, string $event, $object = null): void
    {
        try {
            $location = $this->getLocationInfo();
            $city = $location['data']['city'] ?? '-';
            $country = $location['data']['country'] ?? '-';
            $ip = $this->getIp();

            // إضافة معلومات IP والموقع
            $properties = $data;
            $properties['IP'] = $ip;
            $properties['Country'] = "{$country}-{$city}";

            $userAuth = Auth::user();
            $user = $userAuth->name ?? 'System';

            activity()
                ->useLog($user)
                ->causedBy($userAuth)
                ->performedOn($object)
                ->withProperties($properties)
                ->event($event)
                ->log("{$message}");
        } catch (\Exception $e) {
            Log::error('Activity log failed: '.$e->getMessage());
        }
    }

    /**
     * Log a deletion event.
     */
    public function ActivityLogDestroy($object, string $modelName, string $event = 'Delete'): void
    {
        $this->ActivityLogCreate(
            ['attributes' => $object->toArray()],
            $modelName,
            $event,
            $object
        );
    }

    /**
     * Log an update event with before and after data.
     */
    public function ActivityLogUpdate($object, array $oldData, array $newData, string $modelName): void
    {
        $properties = [
            'old' => $oldData,
            'new' => $newData,
        ];

        $this->ActivityLogCreate($properties, $modelName, 'Update', $object);
    }

    /**
     * Get the client's IP address.
     */
    public function getIp(): string
    {
        $ip = request()->server('HTTP_CF_CONNECTING_IP') // Cloudflare
            ?? request()->server('HTTP_X_FORWARDED_FOR') // Proxies
            ?? request()->server('HTTP_X_REAL_IP')       // Nginx Proxy
            ?? request()->server('REMOTE_ADDR');         // Default

        // في حال كان هناك عدة IP مفصولة بفواصل (في حالة X_FORWARDED_FOR)
        if (strpos($ip, ',') !== false) {
            $ip = explode(',', $ip)[0];
        }

        return trim($ip);
    }

    /**
     * Get location information based on IP address.
     */
    public function getLocationInfo(): array
    {
        $ip = $this->getIp();

        try {
            $response = Http::get("http://ipinfo.io/{$ip}/json");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            }
        } catch (\Exception $e) {
            Log::error('IP location fetch failed: '.$e->getMessage());
        }

        return ['status' => 'error', 'message' => 'Unable to retrieve location data.'];
    }
}
