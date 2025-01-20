const { exec } = require("child_process");

async function globalTeardown() {
  async function teardownBackend() {
    // Encerra o backend
    console.log("Encerrando o servidor backend...");
    exec("cd ../server && ./vendor/bin/sail down", error => {
      if (error) {
        console.error(`Erro ao encerrar o backend: ${error.message}`);
      } else {
        console.log("Servidor backend encerrado.");
      }
    });
  }

  async function teardownFrontend() {
    // Encerra o frontend
    console.log("Encerrando o servidor frontend...");
    exec("pkill -f 'vite preview' && pkill -f 'npm run dev'");
  }

  async function timeout(second) {
    await new Promise(resolve => setTimeout(resolve, second * 1000));
  }

  console.log("");
  await teardownBackend();
  await timeout(5);
  await teardownFrontend();
  await timeout(10);
  console.log("");
  console.log("");
}

module.exports = globalTeardown;
