<div tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="input-group input-group-lg">
          <input type="text" id="customer-name" class="form-control" placeholder="Customer name" aria-label="Large"
            aria-describedby="inputGroup-sizing-sm">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="save-btn" class="btn btn-primary">Save</button>
      </div>
      <a href="http://localhost/ci3_project/index.php/request-list">Go To The Request List</a>
    </div>
  </div>
</div>

<script>
  $(document).on('click', `#save-btn`, () => {
    let data = {
      customer_name: $('#customer-name').val(),
    };
    $.post({
      url: 'http://localhost/ci3_project/index.php/add-customer-request',
      method: 'POST',
      data: data,
      success: (response) => {
        data = {}
        Swal.fire({
          title: "Added Request!",
          icon: "success"
        });
        $('#customer-name').val("");

      },
      error: (e) => {
        console.log(e);
      }
    });
  });
</script>