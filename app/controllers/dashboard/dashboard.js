const navLinks = document.querySelectorAll(".nav-menu > li > a");
const logoutBtn = document.getElementById("logoutBtn");
const notificationBtn = document.getElementById("notificationBtn");
const profileBtn = document.getElementById("profileBtn");


function toggleSubmenu(link) {
  const submenu = link.nextElementSibling;

  if (submenu && submenu.classList.contains("submenu")) {
    
    if (submenu.style.display === "block") {
      submenu.style.display = "none";
    } else {
      submenu.style.display = "block";
    }
  }
}

function handleLogout() {
  const confirmed = confirm("Are you sure you want to logout?");
  if (confirmed) {
    window.location.href = "../../../app/view/auth/login.html"; 
  }
}

function handleNotification() {
  alert("You have no new notifications."); // not done
}

function handleProfile() {
  window.location.href = "../../app/view/profile/profile.html"; // not done
}

navLinks.forEach(link => {
  link.addEventListener("click", function (e) {
    const submenu = this.nextElementSibling;
    if (submenu && submenu.classList.contains("submenu")) {
      e.preventDefault();
      toggleSubmenu(this);
    }
  });
});

if (logoutBtn) {
  logoutBtn.addEventListener("click", handleLogout);
}

if (notificationBtn) {
  notificationBtn.addEventListener("click", handleNotification);
}

if (profileBtn) {
  profileBtn.addEventListener("click", handleProfile);
}
