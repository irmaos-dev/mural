import { z } from 'zod'
import { ImageAspectRatioValidator } from '~6shared/lib/image';

export const CreateArticleSchema = z.object({
  title: z.string().min(1, {
    message: 'The article title must contain at least 1 character.',
  }),
  description: z.string().min(1, {
    message: 'The article description must contain at least 1 character.',
  }),
  body: z.string().min(1, {
    message: 'The article body must contain at least 1 character.',
  }),
  tagList: z.string().optional(),
  image: z.string().refine(
    async (url) => {
      
      if (url !== undefined && url !== '') {
        const validation = await
          ImageAspectRatioValidator (url, 1.7, 1.84);
        return validation;
      } 
      return true;
    },
    {
      message: 'A imagem deve ter uma proporção de 16:9',
    }),
})
export type CreateArticle = z.infer<typeof CreateArticleSchema>
