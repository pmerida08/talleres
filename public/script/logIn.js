document.addEventListener("DOMContentLoaded",()=>{
    document.getElementById('toggle-password').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    
        this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
    });
    
})