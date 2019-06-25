<script type="text/javascript">
$(function() {
  setTimeout(fetchOrderUpdates, 1000)
})
function fetchOrderUpdates() {
  $.post("ajax/fetch_order_updates.php")
  .done(function(response) {
    if (response.indexOf("ERROR") != -1) {
      console.log(response)
    } else {
    if (response !== 'EMPTY') {
        var responseArray = JSON.parse(response)
        $.each(responseArray,
          function(index, it) {
            if (it.status_id != 4) {
              createToast(
                it.status_name,
                it.last_status_update,
                "Il tuo ordine per " + it.order_address + " ha cambiato stato."
              )
            }
          }
        )
      }
    }
  })
  .always(function() {
    setTimeout(fetchOrderUpdates, 1000)
  })
}
</script>
