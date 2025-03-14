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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <script src="scriptnya.js"></script>
    
</body>

</html>