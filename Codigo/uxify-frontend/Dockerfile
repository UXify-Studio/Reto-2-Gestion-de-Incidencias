# Usa una imagen base de Node.js para construir la aplicación
FROM node:18 as build-stage

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . ./
RUN npm run build

# Usa una imagen base de Apache para servir la aplicación
FROM httpd:alpine as production-stage

# Copia los archivos de compilación al directorio raíz de Apache
COPY --from=build-stage /app/dist /usr/local/apache2/htdocs/

# Expone el puerto 80
EXPOSE 80

# Comando para ejecutar Apache (ya es el predeterminado para la imagen httpd)
CMD ["httpd-foreground"]
