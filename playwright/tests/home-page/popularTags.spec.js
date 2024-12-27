const { test, expect } = require("@playwright/test");
const { text } = require("stream/consumers");

test.describe("Teste de filtragem e navegação por tags populares", () => {
  test.setTimeout(120000);
  let selectedButtons = [];

  test.beforeEach(async ({ page }) => {
    await page.goto("/");

    // Espera a aba de tags serem carregadas e visíveis
    await page.waitForSelector(".sidebar > .tag-list", { state: "visible" });

    const buttons = await page.locator(".tag-list button").all();
    if (buttons.length <= 3) {
      selectedButtons = buttons;
    } else {
      selectedButtons = buttons.sort(() => 0.5 - Math.random()).slice(0, 3);
    }
  });

  async function verifyTagTabOpened(button, page) {
    const buttonTagText = await button.textContent();
    await button.click();
    await page.waitForTimeout(1000); // Espera um tempo para carregar os artigos
    await page.waitForSelector(".article-preview", { state: "visible" }); // Verifica que foi carregado e espera mais um pouco se não estiver carregado
    const liButton = page.locator(".nav.nav-pills.outline-active > :last-child > button");
    const liButtonText = await (await liButton.textContent()).replace("#", "").trim();
    expect(liButtonText).toBe(buttonTagText);
    return;
  }

  async function verifyArticlesHaveTag(button, page) {
    await button.click(); // Clica no botão
    await page.waitForTimeout(1000); // Espera um tempo para carregar os artigos
    await page.waitForSelector(".article-preview", { state: "visible" }); // Verifica que foi carregado e espera mais um pouco se não estiver carregado

    const articles = await page.locator(".article-preview").all();
    const buttonTagText = await button.textContent();
    expect(articles.length).toBeGreaterThan(0, `No articles found for tag "${buttonTagText}"`);

    for (const article of articles) {
      const articleTags = await article.locator(".tag-list > li").all();
      const tagTexts = await Promise.all(articleTags.map(tag => tag.textContent()));
      expect(tagTexts).toContain(buttonTagText);
    }
  }

  test("Verifica se a aba correta é aberta ao clicar na tag", async ({ page }) => {
    for (const button of selectedButtons) {
      await verifyTagTabOpened(button, page);
    }
  });

  test("Verifica se todos os artigos contêm a tag clicada", async ({ page }) => {
    for (const button of selectedButtons) {
      await verifyArticlesHaveTag(button, page);
    }
  });
});
