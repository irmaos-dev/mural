# Instalando o docker sem desktop

## Execute o comando para ter certeza de não há vestigios de instalações anteriores

```
for pkg in docker.io docker-doc docker-compose docker-compose-v2 podman-docker containerd runc; do sudo apt-get remove $pkg; done
```

## Rode os comandos para atualizar os certificados

```
sudo apt update && sudo apt install ca-certificates curl
```

## Comandos para adicionar as chaves do Docker

```
sudo install -m 0755 -d /etc/apt/keyrings && sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc && sudo chmod a+r /etc/apt/keyrings/docker.asc
```

## Adicionar o repositorio ao apt

```
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null && sudo apt update
```

## Comando para instalar a ultima versão do docker

```
sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

## Docker sem sudo | postinstall

```
sudo groupadd docker || sudo usermod -aG docker $USER &&  newgrp docker
```

## Para mais dúvidas consulte a [documentação oficial](https://docs.docker.com/engine/install/ubuntu/)
