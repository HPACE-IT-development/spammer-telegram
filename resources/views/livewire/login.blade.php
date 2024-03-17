<div class="w-75 mx-auto">
    <form wire:submit="save" class="w-25 mx-auto d-flex flex-column align-items-center">
        <h2 class="h1 mb-5">Вход</h2>

        <div class="input-group mb-3">
            <span class="input-group-text bg-body-secondary">
                <i class="bi bi-person-fill"></i>
            </span>
            <input
                wire:model="login"
                type="text"
                class="form-control bg-body-secondary border border-start-0 {{$errors->has('login')? 'is-invalid': ''}}"
                name="login"
                placeholder="Логин">

            <div class="invalid-feedback">
                {{$errors->has('login')? $errors->first('login'): ''}}
            </div>
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text bg-body-secondary">
                <i class="bi bi-key-fill"></i>
            </span>

            <input
                wire:model="password"
                type="password"
                class="form-control bg-body-secondary border border-start-0 {{$errors->has('password')? 'is-invalid': ''}}"
                name="password"
                placeholder="Пароль">

            <div class="invalid-feedback">
                {{$errors->has('password')? $errors->first('password'): ''}}
            </div>
        </div>

        <input type="submit" class="form-control btn btn-success bg-gradient fs-6" value="Войти">
    </form>
</div>
