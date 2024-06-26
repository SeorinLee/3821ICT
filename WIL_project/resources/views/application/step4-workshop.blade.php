<!-- resources/views/application/step4-workshop.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span
                style="color: black; background-color: white; padding: 5px; width: 600px; height: 20px; display: inline-block;">
                Step 4: Workshop
            </span>
        </h2>

        <!-- Progress Bar Section -->
        <div class="progress-bar-container"
            style="display: flex; justify-content: space-between; width: 100%; margin: 50px auto; position: relative;">
            @php
                // Define the current step
                $currentStep = "Workshop";

                // Define all steps
                $steps = [
                    "Start" => "application.step0",
                    "Volunteer Details" => "application.step1",
                    "Video & Doc" => "application.step2",
                    "Quiz" => "application.step3",
                    "Workshop" => "application.step4",
                    "Interview" => "application.step5",
                    "Unique Job Plan" => "application.step6",
                    "Finish" => "application.step7"
                ];
            @endphp

            @foreach ($steps as $step => $route)
                        @php
                            // Determine if the current step is completed or not
                            $isCompleted = ($step == $currentStep) ? 'color: black;' : 'color: #888;';
                            $circleColor = ($step == $currentStep) ? 'background-color: dodgerblue;' : '';
                        @endphp

                        <div class="progress-step"
                            style="position: relative; padding: 10px; {{ $isCompleted }} font-size: 14px; text-align: center; flex: 1; cursor: pointer; margin-top: 20px;">
                            <a href="{{ route($route) }}" style="text-decoration: none; color: inherit;">
                                <div
                                    style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); width: 30px; height: 30px; border: 2px solid #ccc; border-radius: 50%; {{ $circleColor }}">
                                </div>
                                {{ $step }}
                            </a>
                            @if (!$loop->first)
                                        @php
                                            // Determine the color of the line connecting the steps
                                            $lineColor = ($step == $currentStep) ? 'background-color: dodgerblue;' : 'background-color: black;';
                                        @endphp
                                        <div
                                            style="position: absolute; top: -12px; left: 0%; width: 80%; transform: translateX(-50%); height: 2px; {{ $lineColor }}">
                                        </div>
                            @endif
                        </div>
            @endforeach
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($application)
                        <!-- Workshop Form -->
                        <form id="workshopForm" action="{{ route('application.storeStep4') }}" method="POST">
                            @csrf
                            <!-- Workshop Information Input -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="workshop_info">
                                    Workshop Information
                                </label>
                                <textarea name="workshop_info" id="workshop_info" rows="4"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>{{ $application->workshop_info }}</textarea>
                            </div>

                            <div class="flex items-center justify-between">
                                <!-- Check Result Button -->
                                <button type="button" id="checkResultButton"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Check Result
                                </button>
                                <!-- Next Button -->
                                <a href="{{ route('application.step5') }}"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Next
                                </a>
                            </div>

                            <!-- Workshop Result Input, initially hidden -->
                            <div class="mb-4" id="workshopResultSection" style="display: none;">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="workshop_result">
                                    Workshop Result
                                </label>
                                <textarea name="workshop_result" id="workshop_result" rows="4"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>{{ $application->workshop_result }}</textarea>
                            </div>
                        </form>
                    @else
                        <p>No application found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show the workshop result section when the Check Result button is clicked
        document.getElementById('checkResultButton').addEventListener('click', function () {
            document.getElementById('workshopResultSection').style.display = 'block';
        });

        // Handle the form submission
        document.getElementById('workshopForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            // Submit the form data using Fetch API
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Workshop details saved successfully.');
                    } else {
                        alert('Failed to save workshop details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to save workshop details.');
                });
        });
    </script>
</x-app-layout>