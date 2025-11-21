// App Manager
class BrightMindsApp {
    constructor() {
        this.hero = document.getElementById('hero');
        this.signupManager = new SignupForm();
        this.loginManager = new LoginForm();
        this.init();
    }

    init() {
        // Show signup form
        document.getElementById('showSignup').addEventListener('click', () => {
            this.hideHero();
            setTimeout(() => this.signupManager.show(), 300);
        });

        // Show login form
        document.getElementById('showLogin').addEventListener('click', () => {
            this.hideHero();
            setTimeout(() => this.loginManager.show(), 300);
        });

        // Handle animals
        document.querySelectorAll('.animal').forEach(animal => {
            animal.addEventListener('click', function() {
                this.style.transform = 'rotate(360deg) scale(1.5)';
                setTimeout(() => this.style.transform = '', 600);
            });
        });

        // Escape key closes forms
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.signupManager.hide();
                this.loginManager.hide();
                setTimeout(() => this.showHero(), 300);
            }
        });
    }

    hideHero() {
        this.hero.classList.add('hide');
    }

    showHero() {
        this.hero.classList.remove('hide');
    }
}

// Signup Form Handler
class SignupForm {
    constructor() {
        this.form = document.getElementById('signupForm');
        this.username = document.getElementById('signupUsername');
        this.email = document.getElementById('signupEmail');
        this.password = document.getElementById('signupPassword');
        this.confirm = document.getElementById('confirmPassword');
        this.submitBtn = document.getElementById('signupSubmit');
        this.selectedAvatar = null;
        
        this.validation = {
            username: false,
            email: false,
            password: false,
            confirm: false,
            avatar: false
        };

        this.init();
    }

    init() {
        // Back button
        document.getElementById('signupBack').addEventListener('click', () => {
            this.hide();
            setTimeout(() => document.getElementById('hero').classList.remove('hide'), 300);
        });

        // Field validation
        this.username.addEventListener('input', () => this.validateUsername());
        this.email.addEventListener('input', () => this.validateEmail());
        this.password.addEventListener('input', () => this.validatePassword());
        this.confirm.addEventListener('input', () => this.validateConfirm());

        // Avatar selection
        document.querySelectorAll('#signupForm .avatar').forEach(avatar => {
            avatar.addEventListener('click', () => this.selectAvatar(avatar));
        });

        // Form submission
        document.getElementById('signup').addEventListener('submit', (e) => {
            if (!this.submit()) {
                e.preventDefault();
            }
        });
    }

    validateUsername() {
        const value = this.username.value;
        if (value.length === 0) {
            this.resetField(this.username);
            this.validation.username = false;
        } else if (value.length >= 3 && value.length <= 20) {
            this.markValid(this.username);
            this.validation.username = true;
        } else {
            this.showError(this.username, '🔤 Name must be 3-20 characters!');
            this.validation.username = false;
        }
        this.checkValid();
    }

    validateEmail() {
        const value = this.email.value;
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (value.length === 0) {
            this.resetField(this.email);
            this.validation.email = false;
        } else if (regex.test(value)) {
            this.markValid(this.email);
            this.validation.email = true;
        } else {
            this.showError(this.email, '📧 Please enter a valid email!');
            this.validation.email = false;
        }
        this.checkValid();
    }

    validatePassword() {
        const value = this.password.value;
        this.updateStrength(value);
        
        if (value.length === 0) {
            this.resetField(this.password);
            this.validation.password = false;
            document.getElementById('strengthFill').style.width = '0';
            document.getElementById('strengthText').textContent = '';
        } else if (value.length >= 6) {
            this.markValid(this.password);
            this.validation.password = true;
        } else {
            this.showError(this.password, '🔐 Password must be at least 6 characters!');
            this.validation.password = false;
        }
        
        if (this.confirm.value) {
            this.validateConfirm();
        }
        this.checkValid();
    }

    validateConfirm() {
        const value = this.confirm.value;
        
        if (value.length === 0) {
            this.resetField(this.confirm);
            this.validation.confirm = false;
        } else if (value === this.password.value) {
            this.markValid(this.confirm);
            this.validation.confirm = true;
        } else {
            this.showError(this.confirm, '🔄 Passwords don\'t match!');
            this.validation.confirm = false;
        }
        this.checkValid();
    }

    updateStrength(password) {
        let strength = 0;
        if (password.length >= 6) strength += 25;
        if (password.length >= 10) strength += 25;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
        if (/\d/.test(password)) strength += 15;
        if (/[!@#$%^&*]/.test(password)) strength += 10;
        strength = Math.min(strength, 100);

        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');
        fill.style.width = strength + '%';

        if (strength < 30) {
            fill.style.background = '#ef4444';
            text.textContent = '💪 Weak - Make it stronger!';
            text.style.color = '#ef4444';
        } else if (strength < 60) {
            fill.style.background = '#f59e0b';
            text.textContent = '👍 Good - Almost there!';
            text.style.color = '#f59e0b';
        } else {
            fill.style.background = '#5fb9d8';
            text.textContent = '🎉 Excellent! Super strong!';
            text.style.color = '#5fb9d8';
        }
    }

    selectAvatar(element) {
        document.querySelectorAll('#signupForm .avatar').forEach(a => a.classList.remove('selected'));
        element.classList.add('selected');
        this.selectedAvatar = element.dataset.avatar;
        document.getElementById('avatarInput').value = this.selectedAvatar;
        this.validation.avatar = true;
        this.checkValid();
    }

    markValid(input) {
        input.classList.remove('invalid');
        input.classList.add('valid');
        input.parentElement.querySelector('.checkmark').classList.add('show');
        input.parentElement.querySelector('.error').classList.remove('show');
    }

    showError(input, message) {
        input.classList.remove('valid');
        input.classList.add('invalid');
        input.parentElement.querySelector('.checkmark').classList.remove('show');
        const error = input.parentElement.querySelector('.error');
        error.textContent = message;
        error.classList.add('show');
    }

    resetField(input) {
        input.classList.remove('valid', 'invalid');
        input.parentElement.querySelector('.checkmark').classList.remove('show');
        input.parentElement.querySelector('.error').classList.remove('show');
    }

    checkValid() {
        const allValid = Object.values(this.validation).every(v => v === true);
        this.submitBtn.disabled = !allValid;
        this.submitBtn.classList.toggle('ready', allValid);
    }

    submit() {
        if (this.submitBtn.disabled) return;

        document.getElementById('signupLoading').classList.add('show');
        this.submitBtn.disabled = true;

        // Form will now submit naturally to backend/signup.php
        return true;
    }

    reset() {
        document.getElementById('signup').reset();
        document.getElementById('signupLoading').classList.remove('show');
        this.hide();
        
        Object.keys(this.validation).forEach(key => this.validation[key] = false);
        document.querySelectorAll('#signupForm .checkmark').forEach(c => c.classList.remove('show'));
        document.querySelectorAll('#signupForm input').forEach(i => i.classList.remove('valid', 'invalid'));
        document.querySelectorAll('#signupForm .avatar').forEach(a => a.classList.remove('selected'));
        document.getElementById('strengthFill').style.width = '0';
        document.getElementById('strengthText').textContent = '';
        this.selectedAvatar = null;
        
        setTimeout(() => document.getElementById('hero').classList.remove('hide'), 300);
    }

    show() {
        this.form.classList.add('show');
    }

    hide() {
        this.form.classList.remove('show');
    }
}

// Login Form Handler
class LoginForm {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.username = document.getElementById('loginUsername');
        this.password = document.getElementById('loginPassword');
        this.submitBtn = document.getElementById('loginSubmit');
        
        this.validation = {
            username: false,
            password: false
        };

        this.init();
    }

    init() {
        // Back button
        document.getElementById('loginBack').addEventListener('click', () => {
            this.hide();
            setTimeout(() => document.getElementById('hero').classList.remove('hide'), 300);
        });

        // Field validation
        this.username.addEventListener('input', () => this.validateUsername());
        this.password.addEventListener('input', () => this.validatePassword());

        // Forgot password
        document.getElementById('forgotPassword').addEventListener('click', (e) => {
            e.preventDefault();
            alert('🤔 No worries!\n\nIn a real app, we would send you an email to reset your password.\n\nFor now, just try to remember! 😊');
        });

        // Form submission
        document.getElementById('login').addEventListener('submit', (e) => {
            if (!this.submit()) {
                e.preventDefault();
            }
        });
    }

    validateUsername() {
        const value = this.username.value;
        
        if (value.length === 0) {
            this.resetField(this.username);
            this.validation.username = false;
        } else if (value.length >= 3) {
            this.markValid(this.username);
            this.validation.username = true;
        } else {
            this.showError(this.username, '🔤 Please enter your name!');
            this.validation.username = false;
        }
        this.checkValid();
    }

    validatePassword() {
        const value = this.password.value;
        
        if (value.length === 0) {
            this.resetField(this.password);
            this.validation.password = false;
        } else if (value.length >= 1) {
            this.markValid(this.password);
            this.validation.password = true;
        } else {
            this.showError(this.password, '🔐 Please enter your password!');
            this.validation.password = false;
        }
        this.checkValid();
    }

    markValid(input) {
        input.classList.remove('invalid');
        input.classList.add('valid');
        input.parentElement.querySelector('.checkmark').classList.add('show');
        input.parentElement.querySelector('.error').classList.remove('show');
    }

    showError(input, message) {
        input.classList.remove('valid');
        input.classList.add('invalid');
        input.parentElement.querySelector('.checkmark').classList.remove('show');
        const error = input.parentElement.querySelector('.error');
        error.textContent = message;
        error.classList.add('show');
    }

    resetField(input) {
        input.classList.remove('valid', 'invalid');
        input.parentElement.querySelector('.checkmark').classList.remove('show');
        input.parentElement.querySelector('.error').classList.remove('show');
    }

    checkValid() {
        const allValid = Object.values(this.validation).every(v => v === true);
        this.submitBtn.disabled = !allValid;
        this.submitBtn.classList.toggle('ready', allValid);
    }

    submit() {
        if (this.submitBtn.disabled) return;

        document.getElementById('loginLoading').classList.add('show');
        this.submitBtn.disabled = true;

        // Form will now submit naturally to backend/login.php
        return true;
    }

    reset() {
        document.getElementById('login').reset();
        document.getElementById('loginLoading').classList.remove('show');
        this.hide();
        
        Object.keys(this.validation).forEach(key => this.validation[key] = false);
        document.querySelectorAll('#loginForm .checkmark').forEach(c => c.classList.remove('show'));
        document.querySelectorAll('#loginForm input').forEach(i => i.classList.remove('valid', 'invalid'));
        
        setTimeout(() => document.getElementById('hero').classList.remove('hide'), 300);
    }

    show() {
        this.form.classList.add('show');
    }

    hide() {
        this.form.classList.remove('show');
    }
}

// Start the app

const app = new BrightMindsApp();
