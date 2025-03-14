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
        <div class="row">
            <div class="col-12" id="data-table">
                <!-- Data Table Here -->

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
                        // load data
                        window.location.reload();
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
                cardHeader.className = "card-header d-flex justify-content-between align-items-center";

                const headerTitle = document.createElement("h3");
                headerTitle.textContent = item.c_title;

                const deleteButton = document.createElement("button");
                deleteButton.textContent = "-";
                deleteButton.className = "btn btn-danger btn-sm";
                deleteButton.onclick = function() {
                    deleteData(item.id);
                };

                cardHeader.appendChild(headerTitle);
                cardHeader.appendChild(deleteButton);

                const cardBody = document.createElement("div");
                cardBody.className = "card-body";

                const eventTime = document.createElement("p");
                const eventDate = new Date(item.c_event_time);
                const formattedDate = `${eventDate.getFullYear()}-${String(eventDate.getMonth() + 1).padStart(2, '0')}-${String(eventDate.getDate()).padStart(2, '0')} ${String(eventDate.getHours()).padStart(2, '0')}:${String(eventDate.getMinutes()).padStart(2, '0')}:${String(eventDate.getSeconds()).padStart(2, '0')}`;
                eventTime.innerHTML = `<strong>${formattedDate}</strong>`;
                eventTime.className = "mb-3";

                const description = document.createElement("p");
                if (item.c_desc.includes(',')) {
                    const list = document.createElement("ul");
                    item.c_desc.split(',').forEach(descItem => {
                        const listItem = document.createElement("li");
                        listItem.textContent = descItem.trim();
                        list.appendChild(listItem);
                    });
                    description.appendChild(list);
                } else {
                    description.textContent = item.c_desc;
                }
                description.className = "mb-3";

                cardBody.appendChild(eventTime);

                const table = document.createElement("table");
                table.className = "table table-bordered";
                table.style.fontSize = "0.8em";

                const thead = document.createElement("thead");
                const headerRow = document.createElement("tr");
                const headers = ["Tahun", "Bulan", "Hari", "Jam", "Menit", "Detik"];
                headers.forEach(header => {
                    const th = document.createElement("th");
                    th.style.textAlign = "center";
                    th.textContent = header;
                    headerRow.appendChild(th);
                });

                table.style.textAlign = "center";
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

                cardBody.appendChild(description);
                cardBody.appendChild(table);
                card.appendChild(cardHeader);
                card.appendChild(cardBody);

                tableContainer.appendChild(card);
            });
        }

        function deleteData(id) {
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    var response = JSON.parse(response);
                    if (response.status === 'success') {
                        window.location.reload();
                    } else {
                        alert('Failed to delete data');
                    }
                }
            });
        }

        setInterval(updateTable, 1000);
        updateTable();
    </script>
</body>

</html>