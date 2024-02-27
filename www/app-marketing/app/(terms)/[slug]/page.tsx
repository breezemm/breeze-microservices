import React from 'react'
import { allPosts, Post } from 'contentlayer/generated'
import MdxComponent from '@/components/MdxComponent'

export async function generateStaticParams() {
  return allPosts.map((post) => ({
    slug: post._raw.flattenedPath,
  }))
}

export default async function Terms({ params }: { params: { slug: string } }) {
  const post = allPosts.find((post) => post._raw.flattenedPath === params.slug)

  return <div className="md:ps-36 md:pe-36 md:pb-[16.3rem] px-6 pb-40">{post && <MdxComponent code={post.body.code} />}</div>
}
