<script>
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
              //(1,'Accettato'),(2,'Rifiutato'),(3,'Concluso'),(4,'In attesa')
              var orderStateChange = (it.status_id == 1 ? "accettato" : it.status_id == 2 ? "rifiutato" : "spedito")
              var subtitle = "Il tuo ordine per " + it.order_address + " delle " + it.creation_time + " è stato " + orderStateChange + ". "
              var rejection = (it.status_id == 2 ? it.rejection_reason == "" ? "Motivo non specificato" : "Motivo: " + it.rejection_reason : "")
              var toast = createToast(
                "Ordine " + orderStateChange,
                it.last_status_update,
                subtitle + rejection,
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
