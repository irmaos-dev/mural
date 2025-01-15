const { test, expect } = require("@playwright/test");
const { selectArticlesForPage } = require("../utils");

test("Verifica o título do artigo na home corresponde ao do artigo", async ({ page }) => {
  await page.goto("/");

  const article = (await selectArticlesForPage(page))[0]; // Pega o primeiro artigo da home
  const titleHome = await article.locator("h1").textContent(); // Pega o título do artigo na home

  await article.click();
  await page.waitForSelector(".article-page", { state: "visible" }); // Espera que a página do artigo seja carregada
  test.step("Verificando link do artigo", async () => {
    await expect(page).toHaveURL(/.*\/article\/.*/);
  });

  const articleTitle = await page.locator("h1").textContent(); // Pega o título do artigo na página

  await test.step("Verificando titulo do artigo", async () => {
    expect(titleHome).toEqual(articleTitle);
  });
});
