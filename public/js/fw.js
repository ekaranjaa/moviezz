document.addEventListener('DOMContentLoaded', function () {
    var modals = document.querySelectorAll('.modal')
    var tabs = document.querySelectorAll('.tabs')
    let selectInputs = document.querySelectorAll('select')
    let dropdowns = document.querySelectorAll('.dropdown-trigger')

    M.Modal.init(modals)
    M.Tabs.init(tabs)
    M.FormSelect.init(selectInputs)
    M.Dropdown.init(dropdowns)
})
