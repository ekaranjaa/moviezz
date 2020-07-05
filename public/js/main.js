window.onload = () => {
  const searchToggle = document.getElementById("searchToggle");
  const searchForm = document.getElementById("searchForm");
  const feedback = document.getElementById("feedback");
  const modalToggle = document.getElementById("modalToggle");
  const modal = document.getElementById("modal");
  const modalClose = document.getElementById("modalClose");
  const avatar = document.getElementById("avatar");
  const profileMenu = document.getElementById("profileMenu");

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
