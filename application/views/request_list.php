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

<script>

const getAll = () =>{
  $.get({
    url: 'http://localhost/ci3_project/index.php/task-list-by-ajax',
    method: 'GET',
    data:{"only_requests":true},
    success: (d) => {
      let response = JSON.parse(d);
      let h = "";
      response.forEach((element, i) => {
        console.log(element.status);
        
        h += ` <tr>
                <th scope="row">${i + 1}</th>
                <td>${element.customer_name}</td>
                <td>${element.created_at}</td>
                <td><button  ${+element.status === 1 ? 'disabled' : `data-role="remove-from-db" data-task="${element.id}"`}  ${+element.status === 1 ? 'class="bg-warning"' : 'class="bg-danger"'} >${+element.status === 1 ? 'Already added' : "Remove"} </button></td>
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
  $(document).on("click", `[data-role="remove-from-db"]`, function () {
    let id = $(this).data('task');
    let data = { id: id };
    $.post({
      url: 'http://localhost/ci3_project/index.php/delete-request',
      method: 'POST',
      data: data,
      success: (d) => {
        data = {}
        Swal.fire({
          title: "Removed customer from database!",
          icon: "success"
        });
        getAll();
      },
      error: (e) => {
        console.log(e);
      }
    });
  })
</script>