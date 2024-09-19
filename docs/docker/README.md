# Docker Build

## Compilando imagem Docker

```bash
git clone https://github.com/irmaos-dev/mural.git --branch feat/issue-15-montar-dockerimage-com-client-e-server
cd mural
docker build -f ./docs/docker/Dockerfile --tag irmaodev/mural:dev . 
```

## Executando imagem

```bash
docker run -d --name mural \
  -p 8080:80 \
  -e DB_HOST=seuhost.postgres \
  -e DB_DATABASE=nome_do_bancodedados \
  -e DB_USERNAME=usuario_do_bancodedados \
  -e DB_PASSWORD=senha_do_usuario_do_bancodedados \
  irmaodev/mural:dev
```

## Comandos úteis

### 1. Acessando bash do container

```bash
docker exec -it mural bash
```

### 2. Obtendo logs de acesso e erros

```bash
# log de acessos
docker exec mural cat /var/log/nginx/access.log

# log de erros
docker exec mural cat /var/log/nginx/error.log
```