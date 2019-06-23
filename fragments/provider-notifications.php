<script type="text/javascript">
$(function() {
  $("#buttonCreateToast").on('click', function() {
    var toast = $(`<div class="toast" role="alert" aria-live="assertive" aria-atomic="false" data-autohide="false" style="min-width: 230px; max-width: 450px">
      <div class="toast-header">
        <strong class="mr-auto pr-2">Toast title</strong>
        <small class="pl-2">Small text</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        This is a provider notification!
      </div>
    </div>`)
    $("#notificationArea").append(toast)
    toast.toast('show')
  })
})
</script>
