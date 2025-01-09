const { exec } = require("child_process");
const waitOn = require("wait-on");

async function globalSetup() {
  async function initServerBack() {
    // Inicia o servidor backend
    console.log("Iniciando o servidor backend...");
    const backend = await exec("cd ../server && ./vendor/bin/sail up -d", error => {
      if (error) {
        console.error(`Erro ao iniciar o backend: ${error.message}`);
        process.exit(1);
      }
    });
    //Espera o backend estar disponível
    await waitOn({ resources: ["tcp:127.0.0.1:8081"], delay: 2000, timeout: 60000 });
  }

  async function initServerFront() {
    // Inicia o servidor frontend
    console.log("Iniciando o servidor frontend...");
    const frontend = await exec("cd ../client && npm run dev -- --host 127.0.0.1 --port 3000");
    //Espera o frontend estar disponível
    await waitOn({ resources: ["tcp:127.0.0.1:3000"], delay: 2000, timeout: 60000 });
  }

  async function timeout(second) {
    await new Promise(resolve => setTimeout(resolve, second * 1000));
  }

  await initServerBack();
  await timeout(5);
  await initServerFront();
  await timeout(10);
  console.log("Servidores inicializados com sucesso!");
  await timeout(2);
  console.clear();
  await timeout(10);
}

module.exports = globalSetup;
