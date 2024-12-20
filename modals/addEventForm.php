<div class="modal fade" id="staticBackdropedit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #EE4C51; color: white;">
                <h5 class="modal-title" id="staticBackdropLabel">Add Proposed Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="form-add-event">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="event_name" name="event_name" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-2">
                        <label for="event_venue" class="form-label">Event Venue</label>
                        <input type="text" class="form-control" id="event_venue" name="event_venue" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-2">
                        <label for="event_description" class="form-label">Event Description</label>
                        <textarea class="form-control" id="event_description" name="event_description"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-2">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= date('Y-m-d') ?>" />
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-2">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?= date('H:i') ?>"/>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-2">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" />
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-2">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="text" class="form-control" id="capacity" name="capacity" />
                        <div class="invalid-feedback"></div>
                    </div>
                    <div id="timeErr" class="text-danger"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary brand-bg-color">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>