# Sistema de Gestión de Usuarios - Cotizador

## 🎯 **Descripción**
Sistema completo de gestión de usuarios con roles de administrador, supervisor y vendedor para el sistema de cotizador.

## 👥 **Roles de Usuario**

### **1. Administrador (Admin)**
- ✅ Acceso completo al sistema
- ✅ Gestionar todos los usuarios
- ✅ Crear, editar, eliminar usuarios
- ✅ Cambiar roles y estados
- ✅ Acceso a todas las funcionalidades

### **2. Supervisor**
- ✅ Gestionar usuarios (excepto administradores)
- ✅ Ver reportes y estadísticas
- ✅ Acceso a cotizaciones y clientes
- ✅ No puede cambiar roles de administradores

### **3. Vendedor**
- ✅ Acceso limitado al sistema
- ✅ Solo puede ver cotizaciones y clientes
- ✅ No puede gestionar usuarios
- ✅ Acceso básico al dashboard

## 🚀 **Instalación**

### **1. Base de Datos**
```sql
-- Ejecutar el archivo: database/users_table.sql
-- Esto creará la tabla users y un usuario administrador por defecto
```

### **2. Credenciales por Defecto**
- **Usuario:** `admin`
- **Contraseña:** `password`
- **Rol:** Administrador

### **3. Configuración**
- Asegúrate de que la base de datos esté configurada en `application/config/database.php`
- El modelo `User_model` se carga automáticamente

## 📁 **Archivos Creados**

### **Modelos**
- `application/models/User_model.php` - Gestión de usuarios

### **Controladores**
- `application/controllers/Users.php` - CRUD de usuarios
- `application/controllers/Login.php` - Actualizado para usar roles

### **Vistas**
- `application/views/users/index.php` - Lista de usuarios
- `application/views/users/create.php` - Crear usuario
- `application/views/dashboard_view.php` - Actualizado con enlaces

### **Base de Datos**
- `database/users_table.sql` - Estructura de la tabla

## 🔐 **Funcionalidades de Seguridad**

### **Validaciones**
- Username único
- Email único
- Contraseña mínima 6 caracteres
- Confirmación de contraseña
- Validación de roles permitidos

### **Protecciones**
- Solo admin y supervisor pueden gestionar usuarios
- No se puede eliminar la propia cuenta
- No se puede desactivar la propia cuenta
- Contraseñas hasheadas con `password_hash()`

### **Sesiones**
- Verificación de autenticación en cada controlador
- Verificación de roles para accesos específicos
- Datos del usuario almacenados en sesión

## 🎨 **Características del Frontend**

### **Diseño**
- Bootstrap 5 responsivo
- Colores personalizados (#1D1D1B, #FEC422, #FFFFFF)
- Iconos Font Awesome
- DataTables para la lista de usuarios

### **Funcionalidades**
- Estadísticas en tiempo real
- Filtros y búsqueda avanzada
- Paginación automática
- Acciones inline (editar, activar/desactivar, eliminar)
- Formularios con validación en tiempo real

## 📊 **Estadísticas Disponibles**

- Total de usuarios
- Usuarios activos/inactivos
- Conteo por rol (admin, supervisor, vendedor)
- Fechas de creación y última actualización

## 🛠️ **Uso del Sistema**

### **Acceder a Gestión de Usuarios**
```
URL: /users
Requerido: Rol admin o supervisor
```

### **Crear Nuevo Usuario**
```
URL: /users/create
Requerido: Rol admin o supervisor
```

### **Editar Usuario**
```
URL: /users/edit/{id}
Requerido: Rol admin o supervisor
```

### **Mi Perfil**
```
URL: /users/profile
Requerido: Usuario autenticado
```

## 🔧 **Personalización**

### **Agregar Nuevos Roles**
1. Modificar el enum en la base de datos
2. Actualizar las validaciones en el controlador
3. Agregar estilos CSS para los nuevos badges
4. Actualizar las verificaciones de permisos

### **Cambiar Colores**
- Modificar las variables CSS en `:root`
- Los colores principales están en las vistas

### **Agregar Campos**
1. Modificar la tabla `users`
2. Actualizar el modelo `User_model`
3. Modificar los formularios de creación/edición
4. Actualizar las vistas de listado

## 🚨 **Notas Importantes**

1. **Cambiar contraseña por defecto** del administrador después del primer login
2. **Configurar base_url** en `application/config/config.php`
3. **Verificar permisos** de la carpeta `assets` para el logo
4. **Hacer backup** de la base de datos antes de ejecutar el SQL

## 📞 **Soporte**

Para dudas o problemas:
- Revisar los logs de CodeIgniter en `application/logs/`
- Verificar la configuración de la base de datos
- Comprobar que todos los archivos estén en las ubicaciones correctas

## 🔄 **Próximas Mejoras**

- [ ] Recuperación de contraseña por email
- [ ] Historial de cambios de usuarios
- [ ] Logs de actividad
- [ ] Importación masiva de usuarios
- [ ] Exportación de datos
- [ ] Filtros avanzados por rol y estado
