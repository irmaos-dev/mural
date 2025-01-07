const { test, expect } = require("@playwright/test");
const { selectArticlesForPage } = require("../../utils");

test("Verifica se os campos obrigatórios do artigo estão conforme o esperado", async ({ page }) => {
  test.setTimeout(120000);

  await page.goto("/");

  const selectedArticles = await selectArticlesForPage(page);

  for (const article of selectedArticles) {
    test.step("Verificando descrição do artigo", async () => {
      const articleDescription = await article.locator("div > p");
      await expect(articleDescription).toBeVisible();
      await expect(articleDescription.textContent()).not.toBe("");
    });

    await test.step("Clica e espera pagina do artigo carregar", async () => {
      await article.waitFor({ state: "visible" });
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
      const textContent = await page.locator(".row.article-content p");
      await expect(textContent).toBeVisible();
      await expect(textContent.textContent()).not.toBe("");
    });

    await page.goBack();
  }
});
