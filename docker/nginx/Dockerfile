FROM nginx:alpine

# Copy custom nginx config
COPY conf.d/app.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

# Set permissions
RUN chown -R nginx:nginx /var/www
