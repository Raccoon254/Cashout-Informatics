<x-app-layout>
        <!-- Other meta tags, styles, and scripts... -->
        <script src="https://cdn.jsdelivr.net/npm/spin-wheel@4.2.0/dist/spin-wheel-iife.js"></script>

    <div class="wheel-container">
        <canvas id="wheel" width="300" height="300"></canvas>
    </div>

    <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="spinButton">Spin to Win</button>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/easing-utils@2.0.0/dist/easing-utils.min.js"></script>

    <script>
        document.getElementById("spinButton").addEventListener("click", async () => {
            // Call your Laravel backend API to get the winning item index and duration
            const response = await axios.get('/api/getWinningItem');
            // Define your own easing function
            const myEasingFunction = (n) => n * n;

            const winningItemIndex = response.data.winningItemIndex;
            const duration = response.data.duration;
            const easing = myEasingFunction; // Use an appropriate easing function from the "easing-utils" library or create your own.

            // Get the "wheel" element from the DOM
            const wheelCanvas = document.getElementById("wheel");
            const ctx = wheelCanvas.getContext("2d");

            // Create the wheel instance and spin to the winning item
            const wheel = new Wheel(wheelCanvas, {
                items: [
                    { label: 'Prize 1' },
                    { label: 'Prize 2' },
                    { label: 'Prize 3' },
                    // Add more prize items as needed
                ]
            });

            wheel.spinToItem(winningItemIndex, duration, true, 2, easing);
        });
    </script>


</x-app-layout>
