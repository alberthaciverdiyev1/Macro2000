<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Customer name</th>
      <th scope="col">Date</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody id="table-body">

  </tbody>
</table>
<div class="d-none" id="rejectModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reject reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea name="comment" id="comment"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-modal">Close</button>
        <button type="button" id="reject-btn" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
<script>

const getAll = () =>{
  $.get({
    url: 'http://localhost/ci3_project/index.php/task-list-by-ajax',
    method: 'GET',
    success: (d) => {
      let response = JSON.parse(d);
      let h = "";
      response.forEach((element, i) => {
        console.log(element.status);
        
        h += ` <tr>
                <th scope="row">${i + 1}</th>
                <td>${element.customer_name}</td>
                <td>${element.created_at}</td>
                <td>
                  <button  ${+element.status === 1 ? 'disabled' : `data-role="add-to-db" data-task="${element.id}"`}  ${+element.status === 1 ? 'class="bg-warning"' : 'class="bg-success"'} >${+element.status === 1 ? 'Already added' : "Add"} </button>
                ${+element.status === 0 ? `
                  <button data-role="reject-request" data-task="${element.id}" class="bg-danger">Reject</button>
                  `: ""}
                  </td>
               </tr>`
      });
      $('#table-body').html(h)
    },
    error: (e) => {
      console.log(e);
    }
  });
}
getAll();
  $(document).on("click", `[data-role="add-to-db"]`, function () {
    let id = $(this).data('task');
    let data = { id: id };
    $.post({
      url: 'http://localhost/ci3_project/index.php/add-new-customer',
      method: 'POST',
      data: data,
      success: (d) => {
        data = {}
        Swal.fire({
          title: "Added customer to database!",
          icon: "success"
        });
        getAll();
      },
      error: (e) => {
        console.log(e);
      }
    });
  });

  $(document).on("click", `[data-role="reject-request"]`, function () {
    let id = $(this).data('task');
    let data = { id: id };
      $(`#rejectModal`).removeClass('d-none')
  })
  $(document).on("click", `#close-modal`, function () {
      $(`#rejectModal`).addClass('d-none');
  })
</script>