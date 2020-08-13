const searchToggle = document.getElementById("searchToggle")
const searchForm = document.getElementById("searchForm")
searchToggle.onclick = () => {
  if (searchForm.classList.contains("-mt-16")) {
    searchForm.classList.replace("-mt-16", "mt-16")
  } else if (searchForm.classList.contains("mt-16")) {
    searchForm.classList.replace("mt-16", "-mt-16")
  }
}

const feedback = document.getElementById("feedback")
setTimeout(() => {
  feedback.classList.add("hidden")
}, 3000)

const modalToggle = document.getElementById("modalToggle")
const modal = document.getElementById("modal")
const modalClose = document.getElementById("modalClose")
modalToggle.onclick = () => {
  if (modal.classList.contains("hidden")) {
    modal.classList.remove("hidden")
    document.body.classList.add("overflow-hidden")
    sessionStorage.setItem('modal', 'open')
  } else {
    modal.classList.add("hidden")
    document.body.classList.remove("overflow-hidden")
    sessionStorage.setItem('modal', 'close')
  }
}

window.onload = () => {
  const modalStatus = sessionStorage.getItem('modal')
  if (modalStatus === 'open') {
    modal.classList.remove("hidden")
    document.body.classList.add("overflow-hidden")
  }
}

modalClose.onclick = () => {
  modal.classList.add("hidden")
  document.body.classList.remove("overflow-hidden")
  sessionStorage.setItem('modal', 'close')
}

document.body.onkeydown = e => {
  if (e.key === 'Escape') {
    modal.classList.add("hidden")
    document.body.classList.remove("overflow-hidden")
    sessionStorage.setItem('modal', 'close')
  }
}

const avatar = document.getElementById("avatar")
const profileMenu = document.getElementById("profileMenu")
avatar.onclick = () => {
  if (profileMenu.classList.contains("hidden")) {
    profileMenu.classList.remove("hidden")
  } else {
    profileMenu.classList.add("hidden")
  }
}

function previewImage(e) {
  console.log(e.target)
  const previewEl = e.target.parentElement.previousElementSibling.firstElementChild
  console.log(previewEl)
  previewEl.src = URL.createObjectURL(e.target.files[0])
  previewEl.onload = () => URL.revokeObjectURL(previewEl.src)
}

const movieForm = document.getElementById('movieForm')
movieForm.onsubmit = e => {
  // e.preventDefaukt()
  sessionStorage.setItem('modal', 'close')
}


