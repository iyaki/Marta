FROM mcr.microsoft.com/devcontainers/php:1-8.2-bullseye

ENV TZ=America/Argentina/Buenos_Aires

ENV LANG C.UTF-8
ENV LC_ALL C.UTF-8

RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
	&& curl -1sLf 'https://dl.cloudsmith.io/public/evilmartians/lefthook/setup.deb.sh' | sudo -E bash \
	&& apt-get update \
	&& apt-get install \
		--assume-yes \
		--quiet \
		--no-install-recommends \
		--purge \
		bash-completion \
		lefthook \
		mariadb-client \
		libzip-dev \
		zip \
	&& apt-get clean -y && rm -rf /var/lib/apt/lists/* \
	&& composer completion bash > /usr/share/bash-completion/completions/composer \
	&& lefthook completion bash > /usr/share/bash-completion/completions/lefthook \
	&& cp /home/vscode/.bashrc /root/.bashrc \
	&& cp /home/vscode/.profile /root/.profile

# Install php-pgsql driver
RUN docker-php-ext-install \
	mysqli \
	pdo \
	pdo_mysql \
	zip

# Path para ejecutar binarios por proyecto
ENV PATH="./vendor/bin:${PATH}"

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1
