<form method="POST" action="{{ route('password.update') }}" >
    <h2>Reset Password</h2>
    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
    </div>
    <div>
        <input type="hidden" name="token" value="{{ htmlspecialchars($token) }}">
    </div>
    <button type="submit">Reset Password</button>
</form>

<style>
    form {
        width: 500px;
        margin: auto;
        padding: 20px;
        border: 0.5px solid black;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    h2 {
        text-align: center;
        font-weight: bold;
    }

    div {
        margin-bottom: 10px;
    }

    label {
        display: block;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
    }

    button[type="submit"] {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: rgb(258, 187, 0);
        color: white;
        border: none;
        cursor: pointer;
    }
</style>
