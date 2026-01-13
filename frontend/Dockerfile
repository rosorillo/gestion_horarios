FROM node:20

WORKDIR /app

# Cache de dependencias
COPY package.json package-lock.json* ./
RUN npm install

# Código
COPY . .

EXPOSE 4200
CMD ["npm", "start", "--", "--host", "0.0.0.0", "--port", "4200"]
