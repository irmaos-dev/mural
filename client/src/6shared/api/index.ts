import axios, { AxiosError } from 'axios'
import { z } from 'zod'

export const realworld = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
})

export function handleGenericError(error: AxiosError) {
  /**
   * spec told that only 422 status code should return GenericError errors
   * but sometimes responses with other statuses returns
   * the same shape of error, this is a reason why we cant use this code
   * and have to validate each response
   * @see https://realworld-docs.netlify.app/docs/specs/frontend-specs/swagger
   */
  // if (error.response?.status !== 422) {
  //   return Promise.reject(error)
  // }

  const validation = ErrorSchema.safeParse(error.response?.data);

  if (validation.error) {
    return error
  }

  const {message} = validation.data;
  const {file} = validation.data;
  const {line} = validation.data;
  const stack =`File: ${file}\nLine: ${line}`;

  return { 
    message,
    stack
  }
}

const ErrorSchema = z.object({
  message: z.string(),
  exception: z.string(),
  file: z.string(),
  line: z.number(),
  trace: z.array(
    z.object({
      file: z.string(),
      line: z.number(),
      function: z.string(),
      class: z.string().optional(),
      type: z.string().optional()
    })
  )
});