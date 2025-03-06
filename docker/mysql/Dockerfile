FROM mysql:8.0

# Custom MySQL configuration
COPY my.cnf /etc/mysql/conf.d/my.cnf

# Set proper permissions for MySQL data directory
RUN chown -R mysql:mysql /var/lib/mysql && \
    chmod -R 755 /var/lib/mysql
