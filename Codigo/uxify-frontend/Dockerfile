# Usa una imagen base de Node.js para construir la aplicación
FROM node:18 as build-stage

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . ./
RUN npm run build

# Usa una imagen base de Apache para servir la aplicación
FROM httpd:alpine as production-stage

# Habilitar el módulo rewrite de Apache
RUN sed -i 's/#LoadModule rewrite_module/LoadModule rewrite_module/' /usr/local/apache2/conf/httpd.conf

# Copia los archivos de compilación al directorio raíz de Apache
COPY --from=build-stage /app/dist /usr/local/apache2/htdocs/

# Copia el archivo .htaccess al directorio raíz de Apache
COPY .htaccess /usr/local/apache2/htdocs/.htaccess

# Expone el puerto 80
EXPOSE 80

# Comando para ejecutar Apache
CMD ["httpd-foreground"]
