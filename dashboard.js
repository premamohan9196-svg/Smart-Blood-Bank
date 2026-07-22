// ===============================
// Smart Blood Bank Dashboard JS
// ===============================

document.addEventListener("DOMContentLoaded", function () {

    // ===============================
    // Counter Animation
    // ===============================
    const counters = document.querySelectorAll(".counter");

    counters.forEach(counter => {

        const target = parseInt(counter.innerText) || 0;
        let count = 0;
        const speed = Math.max(1, Math.ceil(target / 80));

        function updateCounter() {

            count += speed;

            if (count >= target) {
                counter.innerText = target;
            } else {
                counter.innerText = count;
                requestAnimationFrame(updateCounter);
            }
        }

        updateCounter();

    });

    // ===============================
    // Fade Animation on Scroll
    // ===============================
    const items = document.querySelectorAll(
        ".welcome-card, .info-card, .action-card, .count-card, .card"
    );

    const observer = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                entry.target.classList.add("show");

            }

        });

    }, {
        threshold: 0.15
    });

    items.forEach(item => {

        item.classList.add("hidden");
        observer.observe(item);

    });

    // ===============================
    // Blood Statistics Chart
    // ===============================
    const chartCanvas = document.getElementById("bloodChart");

    if (chartCanvas) {

        new Chart(chartCanvas, {

            type: "bar",

            data: {

                labels: ["A+", "B+", "O+", "AB+"],

                datasets: [{

                    label: "Available Donors",

                    data: [
                        Number(chartCanvas.dataset.a),
                        Number(chartCanvas.dataset.b),
                        Number(chartCanvas.dataset.o),
                        Number(chartCanvas.dataset.ab)
                    ],

                    backgroundColor: [
                        "#dc3545",
                        "#198754",
                        "#0d6efd",
                        "#ffc107"
                    ],

                    borderRadius: 12

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {

                        display: false

                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {

                            precision: 0

                        }

                    }

                }

            }

        });

    }

});