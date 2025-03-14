
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Saved',
                            text: 'Your data has been successfully saved!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            $('#c_keygen_success').show();
                            $('#c_title').val('');
                            $('#c_desc').val('');
                            $('#c_event').val('');
                            $('#c_keygen').val('');
                            // load data
                            window.location.reload();
                        });
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
            const currentDate = new Date();
            const keygenkey = `${currentDate.toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase()}-msbrewwc`;
            

            Swal.fire({
                title: 'Enter Keygen',
                input: 'text',
                inputPlaceholder: 'Enter your keygen here',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (keygen) => {
                    return new Promise((resolve, reject) => {
                        if (keygen.trim() === '') {
                            reject('Keygen cannot be empty!');
                        } else if (keygen !== keygenkey) {
                            reject('Invalid keygen!');
                        } else {
                            resolve(keygen);
                        }
                    }).catch(error => {
                        Swal.showValidationMessage(error);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            var response = JSON.parse(response);
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Your data has been deleted.',
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete data.',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        }

        setInterval(updateTable, 1000);
        updateTable();