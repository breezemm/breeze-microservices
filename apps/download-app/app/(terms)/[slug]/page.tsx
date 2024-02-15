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

  return <div className="p-4 py-20 md:px-24">{post && <MdxComponent code={post.body.code} />}</div>
}
