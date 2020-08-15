// Handle all search functions
const searchToggle = document.getElementById("searchToggle")
const searchForm = document.getElementById("searchForm")
const searchInput = document.getElementById('searchInput')
searchToggle.onclick = () => {
  if (searchForm.classList.contains("-mt-16")) {
    searchForm.classList.replace("-mt-16", "mt-16")
  } else if (searchForm.classList.contains("mt-16")) {
    searchForm.classList.replace("mt-16", "-mt-16")
  }
}

searchInput.onfocus = e => {
  e.target.parentElement.nextElementSibling.classList.remove('hidden')
  const genresContainer = document.querySelector('.search_suggestions .genres')
  const req = new HTTP

  genresContainer.innerHTML = ''

  req.get(`http://moviezz.test/search/genres/genre`)
    .then(genres => {
      if (genres.length === 0) genresContainer.innerHTML = 'No genres yet'
      genres.forEach(genre => {
        genresContainer.innerHTML += `
          <a href="/movie/genre/${genre.genre}" class="genre m-1 py-2 px-4 rounded-full bg-gray-900 hover:shadow-lg focus:shadow-outline text-sm">${genre.genre}</a>
        `
      })
    })
    .catch(err => console.log(err))
}

searchInput.onblur = e => {
  setTimeout(() => {
    e.target.parentElement.nextElementSibling.classList.add('hidden')
  }, 200)
}

searchInput.onkeyup = e => {
  const suggestionsContainer = document.querySelector('.search_suggestions .suggestions')
  const req = new HTTP

  suggestionsContainer.innerHTML = ''

  if (e.target.value.length > 0) {
    req.get(`http://moviezz.test/search/api?query=${e.target.value}`)
      .then(movies => {
        movies.forEach(movie => {
          suggestionsContainer.innerHTML += `
            <a href="/movie/display/${movie.slug}">
              <div class="card my-1 py-1 px-2 w-full flex items-center rounded hover:bg-gray-700 overflow-hidden">
                  <div class="head h-12 w-12 rounded overflow-hidden">
                      <img loading="lazy" src="/images/thumbnails/${movie.thumbnail}" alt="${movie.name}" class="h-full" />
                  </div>
                  <div class="body py-1 px-2">
                      <div class="flex items-center justify-between">
                          <div>
                              <p class="p-name block text-xl font-medium truncate">${movie.name}</p>
                              <p class="price text-red-300 text-sm">Ksh. ${movie.price}</p>
                          </div>
                      </div>
                  </div>
              </div>
            </a>
          `
        })
      })
      .catch(err => console.log(err))
  }
}

// Hide alert box after 3secs
const feedback = document.getElementById("feedback")
if (document.body.contains(feedback)) {
  setTimeout(() => {
    feedback.classList.add("hidden")
  }, 3000)
}

// Handle all modal features
const modalToggle = document.getElementById("modalToggle")
const modal = document.getElementById("modal")
const modalClose = document.getElementById("modalClose")
if (document.body.contains(modalToggle)) {
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
}

// Toggle menu
const avatar = document.getElementById("avatar")
const profileMenu = document.getElementById("profileMenu")
if (document.body.contains(avatar)) {
  avatar.onclick = () => {
    if (profileMenu.classList.contains("hidden")) {
      profileMenu.classList.remove("hidden")
    } else {
      profileMenu.classList.add("hidden")
    }
  }
}

// Preview image on user select
function previewImage(e) {
  const previewEl = e.target.parentElement.previousElementSibling.firstElementChild
  previewEl.src = URL.createObjectURL(e.target.files[0])
  previewEl.onload = () => URL.revokeObjectURL(previewEl.src)
}

// Handle movie registration
const movieForm = document.getElementById('movieForm')
if (document.body.contains(movieForm)) {
  movieForm.onsubmit = e => {
    // e.preventDefault()
    sessionStorage.setItem('modal', 'close')
  }
}
