# Calculadora IEC

Una aplicación Laravel para cálculos relacionados con el Instituto Ecuatoriano de Crédito Educativo (IEC).

## Requisitos Previos

- Docker Desktop instalado y ejecutándose
- Git
- Composer (opcional, ya que Sail puede manejarlo)

## Instalación y Configuración

### 1. Clonar el Repositorio

```bash
git clone <url-del-repositorio>
cd CalculadoraIEC
```

### 2. Configurar Variables de Entorno

Copia el archivo de configuración de ejemplo:

```bash
cp .env.example .env
```

### 3. Instalar Dependencias con Sail
#### Esto solamente si no tienes composer instalado
Si no tienes Composer instalado localmente, puedes usar Docker para instalar las dependencias:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

#### Si tienes Composer instalado o si estás en Linux o macOS

**En macOS** instala Composer usando Homebrew:
```bash
brew install composer
```

**En Linux** instala Composer:
- Para distribuciones basadas en Debian/Ubuntu:
```bash
sudo apt update
sudo apt install composer
```
- Para distribuciones basadas en Red Hat/CentOS/Fedora:
```bash
sudo dnf install composer
# o en versiones más antiguas
sudo yum install composer
```
- Para Arch Linux:
```bash
sudo pacman -S composer
```

**En Windows** descarga el instalador desde [getcomposer.org](https://getcomposer.org/download/)

Una vez instalado Composer, ejecuta en la carpeta del proyecto:
```bash
composer install
```

### 4. Iniciar el Entorno con Laravel Sail

Una vez instaladas las dependencias, puedes usar Sail:

```bash
# Iniciar los contenedores en segundo plano
./vendor/bin/sail up -d

# O usar el alias (recomendado)
alias sail='./vendor/bin/sail'
sail up -d
```

### 5. Configurar la Aplicación

```bash
# Generar la clave de aplicación
sail artisan key:generate

# Ejecutar migraciones
sail artisan migrate

# (Opcional) Ejecutar seeders
sail artisan db:seed
```

### 6. Instalar Dependencias de Frontend

```bash
# Instalar dependencias de Node.js
sail npm install

# Compilar assets de desarrollo
sail npm run dev

# O para producción
sail npm run build
```

## Uso

### Acceder a la Aplicación

Una vez que los contenedores estén ejecutándose, puedes acceder a:

- **Aplicación web**: http://localhost
- **Mailhog (emails de prueba)**: http://localhost:8025
- **Base de datos**: Puerto 3306 (MySQL)

### Comandos Útiles de Sail

```bash
# Detener los contenedores
sail down

# Ver logs
sail logs

# Ejecutar comandos de Artisan
sail artisan <comando>

# Ejecutar pruebas
sail test

# Acceder al contenedor de la aplicación
sail shell

# Ejecutar comandos de Composer
sail composer <comando>

# Ejecutar comandos de NPM
sail npm <comando>
```

### Configuración de Alias (Recomendado)

Para evitar escribir `./vendor/bin/sail` cada vez, agrega este alias a tu `~/.bashrc` o `~/.zshrc`:

```bash
alias sail='./vendor/bin/sail'
```

Luego recarga tu shell:

```bash
source ~/.bashrc  # o ~/.zshrc
```

## Estructura del Proyecto

- `app/` - Código de la aplicación (Controladores, Modelos, etc.)
- `config/` - Archivos de configuración
- `database/` - Migraciones, seeders y factories
- `public/` - Punto de entrada público
- `resources/` - Vistas, assets y archivos de idioma
- `routes/` - Definición de rutas
- `tests/` - Pruebas automatizadas

## Desarrollo

### Ejecutar Pruebas

```bash
# Ejecutar todas las pruebas
sail test

# Ejecutar pruebas específicas
sail test --filter NombreDeLaPrueba
```

### Debugging

Sail incluye Xdebug preconfigurado. Para habilitarlo:

```bash
sail shell
# Dentro del contenedor
export XDEBUG_MODE=debug
```

## Problemas Comunes

### Puerto ya en uso

Si el puerto 80 está ocupado, puedes cambiar el puerto en el archivo `docker-compose.yml` o usar variables de entorno:

```bash
APP_PORT=8080 sail up -d
```

### Permisos de archivos

Si tienes problemas de permisos:

```bash
sudo chown -R $USER:$USER .
```

## Contribuir

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.