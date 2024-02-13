"use client";
import { useIntersector } from "@/context/interSectorContext";
import useIntersecionObserver from "@/customHooks/useIntersectionObsever";
import { useEffect, useRef } from "react";

const TermsClientWrapper = ({ children }: { children: React.ReactNode }) => {
  const privacyRef = useRef<HTMLDivElement>(null);
  const { observeElement } = useIntersector();
  const isIntersecting = useIntersecionObserver(privacyRef);
  useEffect(() => {
    observeElement(isIntersecting);
  }, [isIntersecting]);
  return <div ref={privacyRef}>{children}</div>;
};

export default TermsClientWrapper;
