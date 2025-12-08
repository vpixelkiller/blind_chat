let currentTab = "login";

const loginForm = document.getElementById("loginFormElement");
const registerForm = document.getElementById("registerFormElement");
const tabs = document.querySelectorAll(".tab");
const loginContainer = document.getElementById("loginForm");
const registerContainer = document.getElementById("registerForm");
const messageDiv = document.getElementById("message");
const generateUserBtn = document.getElementById("generateUserBtn");
const registerUserInput = document.getElementById("registerUser");
const generatedUserSpan = document.getElementById("generatedUser");

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    const tabName = tab.dataset.tab;
    switchTab(tabName);
  });
});

function switchTab(tab) {
  currentTab = tab;
  tabs.forEach((t) => t.classList.remove("active"));
  document.querySelector(`[data-tab="${tab}"]`).classList.add("active");

  loginContainer.classList.toggle("active", tab === "login");
  registerContainer.classList.toggle("active", tab === "register");
  hideMessage();

  if (tab === "register" && !registerUserInput.value) {
    generateUserBtn.click();
  }
}

generateUserBtn.addEventListener("click", async () => {
  try {
    const response = await fetch("generate_user.php");
    const result = await response.json();

    if (result.success) {
      registerUserInput.value = result.user;
      generatedUserSpan.textContent = result.user;
      showMessage("Usuario generado correctamente", "success");
    } else {
      showMessage("Error al generar usuario", "error");
    }
  } catch (error) {
    showMessage("Error de conexión", "error");
    console.error("Error:", error);
  }
});

loginForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const submitBtn = document.getElementById("loginSubmit");
  submitBtn.disabled = true;
  submitBtn.textContent = "Verificando...";

  const user = document.getElementById("loginUser").value;
  const password = document.getElementById("loginPassword").value;

  try {
    const response = await fetch("login.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ user, password }),
    });

    const result = await response.json();

    if (result.success) {
      showMessage("Login exitoso.", "success");
      setTimeout(() => {
        window.location.reload();
      }, 1500);
    } else {
      showMessage(result.message || "Usuario o contraseña incorrectos", "error");
    }
  } catch (error) {
    showMessage("Error de conexión", "error");
    console.error("Error:", error);
  } finally {
    submitBtn.disabled = false;
    submitBtn.textContent = "Iniciar Sesión";
  }
});

registerForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const submitBtn = document.getElementById("registerSubmit");
  submitBtn.disabled = true;
  submitBtn.textContent = "Registrando...";

  const user = document.getElementById("registerUser").value;
  const password = document.getElementById("registerPassword").value;

  if (!user || user === "-") {
    showMessage("Por favor, genera un usuario primero", "error");
    submitBtn.disabled = false;
    submitBtn.textContent = "Registrarse";
    return;
  }

  try {
    const response = await fetch("register.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ user, password }),
    });

    const result = await response.json();

    if (result.success) {
      showMessage("Usuario registrado correctamente. Ahora puedes iniciar sesión.", "success");
      setTimeout(() => {
        switchTab("login");
        document.getElementById("loginUser").value = user;
        document.getElementById("registerPassword").value = "";
      }, 2000);
    } else {
      showMessage(result.message || "Error al registrar usuario", "error");
    }
  } catch (error) {
    showMessage("Error de conexión", "error");
    console.error("Error:", error);
  } finally {
    submitBtn.disabled = false;
    submitBtn.textContent = "Registrarse";
  }
});

function showMessage(text, type) {
  messageDiv.textContent = text;
  messageDiv.className = `message ${type}`;
  setTimeout(() => {
    hideMessage();
  }, 5000);
}

function hideMessage() {
  messageDiv.className = "message";
  messageDiv.textContent = "";
}
