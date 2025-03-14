<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="robot_face.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="container mt-2">
        <h1 class="mb-4" id="add-data">Real-Time Counter</h1>
        <div class="card">
            <div class="card-body" id="data-table">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="6">Skuter Listrik</th>
                                </tr>
                                <tr>
                                    <th colspan="6">2025-12-12 09:00:00</th>
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
                            <tbody style="text-align: right;">
                                <tr>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>3</td>
                                    <td>5</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="c_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="c_title" aria-describedby="c_title">
                            <span id="c_title_error" style="color: #DC3545; display: none;">Title required</span>
                        </div>
                        <div class="mb-3">
                            <label for="c_desc" class="form-label">Description</label>
                            <textarea class="form-control" id="c_desc" rows="3"></textarea>
                            <span id="c_desc_error" style="color: #DC3545; display: none;">Description required</span>
                        </div>
                        <div class="mb-3">
                            <label for="c_event" class="form-label">Event Time</label>
                            <input type="datetime-local" class="form-control" id="c_event">
                            <span id="c_event_error" style="color: #DC3545; display: none;">Event Time required</span>
                        </div>
                        <div class="mb-3">
                            <label for="c_keygen" class="form-label">Keygen</label>
                            <input type="text" class="form-control" id="c_keygen">
                            <span id="c_keygen_error" style="color: #DC3545; display: none;">Keygen required</span>
                            <span id="c_keygen_error2" style="color: #DC3545; display: none;">Wrong keygen</span>
                            <span id="c_keygen_success" style="color:rgb(89, 210, 20); display: none;">Data saved success, reload in 3 second</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        $('#add-data').click(function() {
            $('#modal-add').modal('show');
        });

        // function to save data
        $('#save').click(function() {
            const c_title = $('#c_title').val();
            const c_desc = $('#c_desc').val();
            const c_event = $('#c_event').val();
            const c_keygen = $('#c_keygen').val();

            let isValid = true;

            if (c_title.trim() === '') {
                $('#c_title_error').show();
                isValid = false;
            } else {
                $('#c_title_error').hide();
            }

            if (c_desc.trim() === '') {
                $('#c_desc_error').show();
                isValid = false;
            } else {
                $('#c_desc_error').hide();
            }

            if (c_event.trim() === '') {
                $('#c_event_error').show();
                isValid = false;
            } else {
                $('#c_event_error').hide();
            }

            if (c_keygen.trim() === '') {
                $('#c_keygen_error').show();
                isValid = false;
            } else {
                $('#c_keygen_error').hide();
            }

            if (!isValid) {
                return false;
            }

            $.ajax({
                url: 'insert.php',
                type: 'POST',
                data: {
                    c_title: c_title,
                    c_desc: c_desc,
                    c_event: c_event,
                    c_keygen: c_keygen
                },
                success: function(response) {
                    if (response == 'success') {
                        $('#c_keygen_success').show();
                        $('#c_title').val('');
                        $('#c_desc').val('');
                        $('#c_event').val('');
                        $('#c_keygen').val('');
                        setTimeout(() => {
                            // load data
                            window.location.reload();
                        }, 3000);
                    } else {
                        $('#c_keygen_error2').show();
                    }
                }
            });
        });

        // run get data when document ready
        $(document).ready(function() {
            getData();
        });

        // function to get data
        const data_counter = [];

        function getData() {
            $.ajax({
                url: 'getdata.php',
                type: 'POST',
                success: function(response) {
                    const data = JSON.parse(response);
                    data.forEach(item => {
                        data_counter.push(item);
                    });
                }
            });
        }

        function updateTable() {
            const tableContainer = document.getElementById("data-table");
            tableContainer.innerHTML = "";

            data_counter.forEach(item => {
                const card = document.createElement("div");
                card.className = "card mb-3";

                const cardHeader = document.createElement("div");
                cardHeader.className = "card-header";
                cardHeader.textContent = item.c_title;

                const cardBody = document.createElement("div");
                cardBody.className = "card-body";

                const table = document.createElement("table");
                table.className = "table table-bordered";

                const thead = document.createElement("thead");
                const headerRow = document.createElement("tr");
                const headers = ["Tahun", "Bulan", "Hari", "Jam", "Menit", "Detik"];
                headers.forEach(header => {
                    const th = document.createElement("th");
                    th.textContent = header;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);

                const tbody = document.createElement("tbody");
                const row = document.createElement("tr");

                const startDate = new Date(item.c_event_time);
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

                tbody.appendChild(row);
                table.appendChild(thead);
                table.appendChild(tbody);

                cardBody.appendChild(table);
                card.appendChild(cardHeader);
                card.appendChild(cardBody);

                tableContainer.appendChild(card);
            });
        }

        setInterval(updateTable, 1000);
        updateTable();
    </script>
</body>

</html>