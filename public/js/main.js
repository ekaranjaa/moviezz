window.onload = () => {
  let searchToggle = document.getElementById("searchToggle");
  let searchForm = document.getElementById("searchForm");
  let feedback = document.getElementById("feedback");
  let modalToggle = document.getElementById("modalToggle");
  let modal = document.getElementById("modal");
  let modalClose = document.getElementById("modalClose");
  let avatar = document.getElementById("avatar");
  let profileMenu = document.getElementById("profileMenu");

  searchToggle.onclick = () => {
    if (searchForm.classList.contains("-mt-16")) {
      searchForm.classList.replace("-mt-16", "mt-16");
    } else if (searchForm.classList.contains("mt-16")) {
      searchForm.classList.replace("mt-16", "-mt-16");
    }
  };

  setTimeout(() => {
    feedback.classList.add("hidden");
  }, 3000);

  modalToggle.onclick = () => {
    if (modal.classList.contains("hidden")) {
      modal.classList.remove("hidden");
      document.body.classList.add("overflow-hidden");
    } else {
      modal.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
    }
  };

  modalClose.onclick = () => {
    modal.classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
  };

  avatar.onclick = () => {
    if (profileMenu.classList.contains("hidden")) {
      profileMenu.classList.remove("hidden");
    } else {
      profileMenu.classList.add("hidden");
    }
  };
};
