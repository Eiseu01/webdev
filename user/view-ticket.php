<style>
    input {
        border: none;
    }
    .modal-body {
        display: grid;
        text-align: center;
    }
    .modal-body h1 {
        letter-spacing: 15px;
    }
    .info {
        display: grid;
        text-align: center;
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        padding: 25px 20px;
        border-radius: 15px;
        background-color: #E9AA53;
    }
    input {
        color: black;
        border-radius: 10px;
        padding: 3px;
        border: 1px solid black;
    }
</style>
<div class="modal fade" id="staticBackdropedit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #EE4C51; color: white;">
                <h5 class="modal-title" id="staticBackdropLabel">View Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1>TICKET</h1>
                <div class="info">
                    <input class="text-center" type="text" id="name" disabled>
                    <input class="text-center" type="text" id="event" disabled>
                    <input class="text-center" type="text" id="venue" disabled>
                    <input class="text-center" type="text" id="date" disabled>
                    <input class="text-center" type="text" id="time" disabled>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>