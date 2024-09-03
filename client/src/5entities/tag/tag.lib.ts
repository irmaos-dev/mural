import { tagTypesDto } from '~6shared/api/tag'
import { Tags } from './tag.types'

export function transformTagsDtoToTags(tagsDto: tagTypesDto.TagsDto): Tags {
  return tagsDto.tags
}
