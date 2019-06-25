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
      if (response !== "EMPTY") {
        var responseArray = JSON.parse(response)
        $.each(responseArray,
          function(index, it) {
            if (it.status_id != 4) {
              var toast = createToast(
                "Ordine " + it.status_name.toLowerCase(),
                it.last_status_update,
                "Il tuo ordine per " + it.order_address + " delle " + it.creation_time + " ha cambiato stato",
                "far fa-" + (it.status_id == 2 ? "times" : "check") + "-circle"
              )
              toast['header'].css('background-color', it.status_id == 2 ? '#b72a00' : '#1a8400')
              toast['header'].css('color', 'white')
              toast['element'].toast('show')
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
