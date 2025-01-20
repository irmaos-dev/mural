const { test, expect } = require("@playwright/test");
const { selectArticlesForPage } = require("../utils");

test.describe("Teste na sessão de PopularTags ", () => {
  test.beforeEach(async ({ page }) => {
    await page.goto("/");
    await page.waitForSelector(".home-page", { state: "visible" });
    // Espera a aba de tags serem carregadas e visíveis
    await page.waitForSelector(".sidebar > .tag-list", { state: "visible" });

    page.context().buttons = await page.locator(".sidebar > .tag-list > button").all();
  });

  test("Verifica se a aba correta é aberta ao clicar na tag", async ({ page }) => {
    const button = await page.context().buttons[0]; // Pega o primeiro botão

    const buttonTagText = await button.textContent(); // Pega o texto do botão

    await test.step("Clica no botão e espera aba ser aberta", async () => {
      await button.click();
      await page.waitForTimeout(1000); // Espera um tempo para carregar os artigos
      await page.waitForSelector(".article-preview", { state: "visible" }); // Verifica que foi carregado e espera mais um pouco se não estiver carregado
    });

    const liButton = await page.locator(".nav.nav-pills.outline-active li:last-child button"); // Pega o botão da aba
    const liButtonText = await (await liButton.textContent()).replace("#", "").trim(); // Pega o texto da aba e remove o #

    await test.step("Verifica se a aba da tag foi aberta", async () => {
      await expect(liButton).toBeVisible();
      await expect(
        (
          await page.locator(".home-page .container.page .article-preview").all()
        )[0]
      ).toBeVisible();
    });
    await test.step("Verifica se o texto da aba corresponde ao texto do botão", async () => {
      await expect(liButtonText).toBe(buttonTagText);
    });
  });

  test("Verifica se artigo contém a tag, cujo botão foi clicado", async ({ page }) => {
    const buttons = await page.context().buttons;

    for (const button of buttons) {
      await test.step("Clica no botão e espera página carregar", async () => {
        await button.click(); // Clica no botão
        await page.waitForTimeout(1000); // Espera um tempo para carregar os artigos
        await page.waitForSelector(".article-preview", { state: "visible" }); // Verifica que foi carregado e espera mais um pouco se não estiver carregado
      });

      const buttonTagText = await button.textContent(); //Pega o texto do botão

      const article = (await selectArticlesForPage(page))[0]; // Pega o primeiro artigo

      // Verifica se a aba da tag testada tem artigos
      if ((await article.locator("a").all()).length == 0) {
        await test.step("A tag '${buttonTagText}' não contem artigos, o teste irá para a proxima tag para fazer os testes.", async () => {});

        console.log(
          `A tag '${buttonTagText}' não contem artigos, o teste irá para a proxima tag para fazer os testes.`
        );

        continue; // Pula para outro botão caso não tenha artigos.
      }

      await test.step("Verificando se artigo tem a tag esperada", async () => {
        const articleTags = await article.locator(".tag-list > li").all();
        const tagTexts = await Promise.all(articleTags.map(tag => tag.textContent()));
        await expect(tagTexts.includes(buttonTagText)).toBeTruthy();
      });

      return;
    }
  });
});
