"use client";
import Image from "next/image";
import React, { useEffect, useRef, useState } from "react";
import BreezeIcon from "@/app/assets/breeze_icon.svg";
import Link from "next/link";
import DownloadButton from "@/components/DownloadButton";
import { useIntersector } from "@/context/interSectorContext";
import clsx from "clsx";

const NavBar = () => {
  // const { state } = useIntersector();

  // const navRef = useRef<HTMLDivElement>(null);
  // if (typeof window !== "undefined") {
  //   let prevScrollpos = window.pageYOffset;

  //   window.onscroll = function () {
  //     const currentScrollPos = window.pageYOffset;

  //     if (prevScrollpos > currentScrollPos) {
  //       navRef.current!.style.top = "0";
  //     } else {
  //       navRef.current!.style.top = "-8rem";
  //     }
  //     prevScrollpos = currentScrollPos;
  //   };
  // }

  return (
    <nav
      // ref={navRef}
      // className={clsx(
      //   " top-0 z-20 w-full justify-between   p-4 backdrop-blur-sm transition-all  duration-300 md:px-7 md:py-2 ",
      //   state.isIntersecting ? "fixed  flex items-center  " : "-top-28 "
      // )}
      className="fixed top-0 z-20 flex w-full items-center justify-between px-6 py-4 md:px-10 md:py-6"
    >
      <Link href="/">
        <div className="h-10 w-10  md:h-14 md:w-14">
          <Image src={BreezeIcon} alt="breezicon" />
        </div>
      </Link>

      <Link href="/">
        <DownloadButton />
      </Link>
    </nav>
  );
};

export default NavBar;
