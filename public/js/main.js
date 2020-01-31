let back = document.getElementById('back')
let home = document.getElementById('home')
let forward = document.getElementById('forward')

back.onclick = () => {
    window.history.back()
}

home.onclick = () => {
    window.location.href = '/'
}

forward.onclick = () => {
    window.history.forward()
}