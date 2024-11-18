FROM sail-8.3/app

# Instale as dependências necessárias
RUN apt-get update && apt-get install -y \
    autoconf \
    gcc \
    make \
    unzip

# Clone e instale a extensão OpenTelemetry
RUN pecl install opentelemetry

# Habilite a extensão
RUN mkdir -p /etc/php/8.3/cli/conf.d && echo "extension=opentelemetry.so" > /etc/php/8.3/cli/conf.d/opentelemetry.ini


# Limpe os arquivos temporários
RUN rm -rf /tmp/opentelemetry \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*