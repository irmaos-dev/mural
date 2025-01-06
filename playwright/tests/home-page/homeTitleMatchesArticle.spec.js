const { test, expect } = require("@playwright/test");
const { selectArticlesForPage } = require("../../utils");

test("Verifica o título do artigo na home corresponde ao do artigo", async ({ page }) => {
  test.setTimeout(120000);
  await page.goto("/");

  const selectedArticles = await selectArticlesForPage(page, 0);
  for (const article of selectedArticles) {
    const titleHome = await article.locator("h1").textContent();
    await article.click();
    test.step("Verificando link do artigo", async () => {
      await expect(page).toHaveURL(/.*\/article\/.*/);
    });
    const articleTitle = await page.locator("h1").textContent();
    expect(titleHome).toContain(articleTitle);
    await page.goBack();
  }
});
