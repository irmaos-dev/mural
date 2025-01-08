const { test, expect } = require("@playwright/test");
const { selectArticlesForPage } = require("../utils");

test("Verifica se os campos obrigatórios do artigo estão conforme o esperado", async ({ page }) => {
  await page.goto("/");

  await page.waitForSelector(".article-preview", { state: "visible" }); // Espera que a página da home seja carregada
  const article = (await selectArticlesForPage(page))[0]; // Pega o primeiro artigo da home

  await test.step("Verificando descrição do artigo", async () => {
    const articleDescription = await article.locator("div > p");
    await expect(articleDescription).toBeVisible();
    await expect(articleDescription.textContent()).not.toBe("");
  });

  await test.step("Clica e espera pagina do artigo carregar", async () => {
    await article.click();
    await page.waitForLoadState("domcontentloaded");
    await page.waitForSelector(".article-page", { state: "visible" });
  });

  await test.step("Verificando link do artigo", async () => {
    await expect(page).toHaveURL(/.*\/article\/.*/);
  });

  await test.step("Verificando titulo do artigo", async () => {
    const title = await page.locator("h1");
    await expect(title).toBeVisible();
    await expect(title.textContent()).not.toBe("");
  });

  await test.step("Verificando conteúdo do artigo", async () => {
    const contentArticle = await page.locator(".article-page .row.article-content div p");
    await expect(contentArticle).toBeVisible();
    await expect(contentArticle.textContent()).not.toBe("");
  });
});
