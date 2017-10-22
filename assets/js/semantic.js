$('.ui.dropdown')
  .dropdown()
;
$('.ui.dropdown.athletes')
  .dropdown({
    minCharacters:1
  })
;
$('.ui.accordion')
  .accordion()
;
$('.ui.modal')
  .modal('attach events', '.open.button', 'show')
;
$('#sidebar')
  .sidebar('attach events', '.logo-menu.item')
;
