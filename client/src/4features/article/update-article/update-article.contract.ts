import { z } from 'zod'
import { ImageAspectRatioValidator } from '~6shared/lib/image';

export const UpdateArticleSchema = z.object({
  title: z.string().optional(),
  description: z.string().optional(),
  body: z.string().optional(),
  tagList: z.string().optional(),
  image: z.string().refine(
    async (url) => {

      if (url !== undefined && url !== '') {
        const validation = await
          ImageAspectRatioValidator(url, 1.7, 1.84);
        return validation;
      }
      return true;
    },
    {
      message: 'A imagem deve ter uma proporção de 16:9',
    }),
})

export type UpdateArticle = z.infer<typeof UpdateArticleSchema>
