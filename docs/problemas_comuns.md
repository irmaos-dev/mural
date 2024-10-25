## Erro "Network Error"

Esse erro aparece quando você abre o client mas não abre o server.

## Erro ao rodar comandos com o "Sail"

Ao aparecer a mensagem:

> Cannot connect to the Docker daemon at unix:///var/run/docker.sock. Is the docker daemon running?

Ou algo como "docker-compose não está instalado",

significa que você não abriu o Docker Desktop (assumindo que você fez a instalação padrão com WSL)

## Erro "Something went wrong. The provided data does not meet the required criteria."

Provavelmente você esqueceu de rodar o comando "cp .env.example .env" na pasta "client".

## Erro "Request failed with status code 401"

esse erro foi corrigido pela PR https://github.com/irmaos-dev/mural/pull/52
