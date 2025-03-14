<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container text-center mt-5">
        <h1 class="mb-4">Real-Time Counter</h1>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <!-- <th rowspan="2">Deskripsi</th> -->
                            <th colspan="6">Waktu</th>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Menit</th>
                            <th>Detik</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" style="text-align: right;">
                        <!-- Table rows will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        function updateTable() {
            const data = [{
                    description: "New Phone",
                    date: "2022-10-13 09:00:00"
                },
                {
                    description: "My Born Day",
                    date: "1998-08-23 00:00:00"
                },
                {
                    description: "New Car",
                    date: "2021-11-23 09:00:00"
                }
            ];

            const tableBody = document.getElementById("table-body");
            tableBody.innerHTML = "";

            data.forEach(item => {
                const row = document.createElement("tr");

                const descriptionCell = document.createElement("td");
                // descriptionCell.textContent = item.description;
                // row.appendChild(descriptionCell);

                const startDate = new Date(item.date);
                const now = new Date();
                const diff = now - startDate;

                const years = Math.floor(diff / (1000 * 60 * 60 * 24 * 365));
                const months = Math.floor((diff % (1000 * 60 * 60 * 24 * 365)) / (1000 * 60 * 60 * 24 * 30));
                const days = Math.floor((diff % (1000 * 60 * 60 * 24 * 30)) / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                const timeCells = [years, months, days, hours, minutes, seconds];
                timeCells.forEach(value => {
                    const cell = document.createElement("td");
                    cell.textContent = value;
                    row.appendChild(cell);
                });

                tableBody.appendChild(row);
            });
        }

        setInterval(updateTable, 1000);
        updateTable();
    </script>
</body>

</html>