import { commentTypesDto } from '~6shared/api/comment'
import { sessionTypes } from '~6shared/session'
import { commentTypes } from '~5entities/comment'

export function transformCreateCommentDtoToComment(config: {
  createCommentDto: commentTypesDto.CreateCommentDto
  session: sessionTypes.Session
}): commentTypes.Comment {
  const { createCommentDto, session } = config

  return {
    author: {
      username: session.username,
      bio: session.bio,
      following: false,
      image: session.image,
    },
    body: createCommentDto.body,
    id: Infinity,
    createdAt: new Date(Date.now()),
    updatedAt: new Date(Date.now()),
  }
}
