<div class="modal-header">
  <h5 class="modal-title" id="editarUsuarioLabel">Editar Usuario</h5>
  <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
</div>
{{ html()->modelForm($usuario, 'PATCH')->route('admin.usuarios.usuarios.update',$usuario->id)->attribute('autocomplete', 'off')->open() }}
<div class="modal-body">
  <div class="mb-3">
    <label class="form-label" for="nombre">Nombre:</label>
    <input class="form-control" name="nombre" id="nombre" type="text" placeholder="Ingrese el nombre completo del usuario" value="{{ $usuario->name }}">
  </div>
  <div class="mb-3">
    <label class="form-label" for="email">Email:</label>
    <input class="form-control" name="email" id="email" type="email" placeholder="Ingrese el email del usuario" value="{{ $usuario->email }}">
  </div>
  <label class="form-label" for="password">Contraseña:</label>
  <div class="input-group mb-3">
    <input class="form-control in-pass-s" name="password" id="password" type="password" placeholder="Ingrese la contraseña del usuario" aria-describedby="showpass">
    <button class="btn btn-outline-secondary btn-pass-s" type="button" id="showpass">
      <i class="fa-duotone fa-eye icon"></i>
    </button>
  </div>
  <label class="form-label" for="password-confirm">Confirma Contraseña:</label>
  <div class="input-group mb-3">
    <input class="form-control in-pass-s" name="password_confirmation" id="password-confirm" type="password" placeholder="Confirma la contraseña del usuario" aria-describedby="showpassc">
    <button class="btn btn-outline-secondary btn-pass-s" type="button" id="showpassc">
      <i class="fa-duotone fa-eye icon"></i>
    </button>
  </div>
</div>
<div class="modal-footer">
  <button type="reset" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
  <button type="submit" class="btn btn-primary">Guardar</button>
</div>
{{ html()->form()->close() }}
<script>
  var pass = document.getElementById('password');
  var pass2 = document.getElementById('password-confirm');
  var btn1 = document.querySelector('#showpass');
  var btn2 = document.querySelector('#showpassc');
  var icon1 = document.querySelector('#showpass i');
  var icon2 = document.querySelector('#showpassc i');

  btn1.addEventListener('click', ()=>{
    if (pass.type == 'password') {
      pass.type='text';
      icon1.classList.remove('fa-eye');
      icon1.classList.add('fa-eye-slash');
    } else{
      pass.type='password';
      icon1.classList.remove('fa-eye-slash');
      icon1.classList.add('fa-eye');
    }
  });
  btn2.addEventListener('click', ()=>{
    if (pass2.type == 'password') {
      pass2.type='text';
      icon2.classList.remove('fa-eye');
      icon2.classList.add('fa-eye-slash');
    } else{
      pass2.type='password';
      icon2.classList.remove('fa-eye-slash');
      icon2.classList.add('fa-eye');
    }
  });
</script>