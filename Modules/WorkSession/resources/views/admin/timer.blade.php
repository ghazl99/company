@extends('core::layouts.master')

@section('css')
    {{-- Include Font Awesome CSS if not already included globally --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrojS+w3l+4lM/Pz6jJ5E2iF0r/n/9gM6e7q6E6wJ7Q+q2aG2iC/n6K0PjU7z8jE5tF1aP9nC5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Custom styles for a more engaging look */
        .card-header-icon {
            font-size: 1.5rem;
            margin-inline-end: 10px; /* Adjust spacing for RTL */
            vertical-align: middle;
        }

        .action-button-container {
            margin-top: 20px;
        }

        .start-button {
            padding: 15px 30px;
            font-size: 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .start-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .end-button {
            padding: 15px 30px;
            font-size: 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .end-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .timer-display {
            font-size: 3.5rem; /* Larger font for the timer */
            font-weight: bold;
            color: #007bff; /* Primary blue color */
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 15px 0;
            background: linear-gradient(45deg, #e0f2f7, #cceeff); /* Subtle gradient background */
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
            display: inline-block; /* To allow padding and background on the text itself */
            min-width: 250px; /* Ensure consistent width */
        }

        .session-info {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 15px;
        }

        /* Basic animation for the timer to make it feel alive */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .timer-display.active-pulse {
            animation: pulse 2s infinite ease-in-out;
        }
    </style>
@endsection

@section('content')
    <br>
    <div class="card shadow-sm"> {{-- Added shadow for better depth --}}
        <div class="card-header pb-0 d-flex align-items-center"> {{-- Aligned items for icon and text --}}
            <i class="fas fa-user-clock card-header-icon text-primary"></i> {{-- Clock icon for tracking --}}
            <h4 class="card-title mg-b-0">تتبّع دوام المطور</h4>
            <div class="ms-auto"> {{-- Pushed dots to the end (RTL support) --}}
                <i class="mdi mdi-dots-horizontal text-gray"></i>
            </div>
        </div>
        <div class="card-body">
            <div class="container text-center">
                <h2 class="mb-4 text-dark">سجل ساعات العمل</h2> {{-- Slightly darker text for contrast --}}

                @if (!$activeSession)
                    <div class="action-button-container">
                        <form method="POST" action="{{ route('work.session.start') }}">
                            @csrf
                            <button type="submit" class="btn btn-success start-button">
                                <i class="fas fa-play-circle me-2"></i> بدء الدوام {{-- Play icon --}}
                            </button>
                        </form>
                    </div>
                @else
                    <div class="session-info">
                        <h4>وقت البدء: <span class="text-info">{{ $activeSession->start_time->format('h:i:s A') }}</span></h4>
                        <h4>الوقت المنقضي:</h4>
                    </div>
                    <h1 id="timer" class="text-primary timer-display active-pulse">00:00:00</h1> {{-- Added animation class --}}

                    <div class="action-button-container">
                        <form method="POST" action="{{ route('work.session.end') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger end-button">
                                <i class="fas fa-stop-circle me-2"></i> إنهاء الدوام {{-- Stop icon --}}
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    @if ($activeSession)
        <script>
            // تحويل وقت البدء إلى Timestamp
            const startTime = new Date("{{ $activeSession->start_time->format('Y-m-d H:i:s') }}").getTime();

            // تحديث المؤقت كل ثانية
            setInterval(() => {
                const now = new Date().getTime();
                const diff = now - startTime;

                const hours = Math.floor(diff / (1000 * 60 * 60)).toString().padStart(2, '0');
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                const seconds = Math.floor((diff % (1000 * 60)) / 1000).toString().padStart(2, '0');

                document.getElementById("timer").innerText = `${hours}:${minutes}:${seconds}`;
            }, 1000);
        </script>
    @endif
@endsection
